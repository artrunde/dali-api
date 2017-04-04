#!/bin/bash
GIT_COMMIT_DESC=$(git log --format=oneline -n 1 $1)
ENVIRONMENT=$2

# Get version from filename and trim whitespaces
MAJOR_VERSION=$(<version)
MAJOR_VERSION="$(echo -e "${MAJOR_VERSION}" | tr -d '[:space:]')"
MAJOR_VERSION=${MAJOR_VERSION:1:1}

# Get name of active deployment
ACTIVE_DEPLOYMENT=$(./terraform output -state=terraform-infrastructure/dev/services/rodin/v1/terraform.tfstate active)

function command() {

	if [[ "$GIT_COMMIT_DESC" == *"[deploy=staging]"* ]]; then
		DEPLOYMENT_ACTION="staging"
	elif [[ "$GIT_COMMIT_DESC" == *"[deploy=active]"* ]]; then
		DEPLOYMENT_ACTION="active"
	else
		DEPLOYMENT_ACTION="staging"
	fi

}

function api_test() {

	echo "Running integration test..."
	echo "Sleeping for 20 sec..."
	sleep 20
	ACTIVE_V1_URL=$(./terraform output -json -state=terraform-infrastructure/"$ENVIRONMENT"/services/rodin/v"$MAJOR_VERSION"/terraform.tfstate active_url | jq -r ".value") ./vendor/bin/phpunit

	# Set output from last command
	if [ $? -eq 0 ];then
		echo "Test successful..."
	else
	   echo "Integration test failed!"
	   exit 1
	fi
}

function deploy_staging() {
	echo "Running staging..."
	LAMBDA_FUNCTION=$(./terraform output -json -state=terraform-infrastructure/"$ENVIRONMENT"/services/rodin/v"$MAJOR_VERSION"/terraform.tfstate lambda_integrations | jq -r ".value.$STAGING_DEPLOYMENT")
	S3_DEPLOY_BUCKET=$(./terraform output -json -state=terraform-infrastructure/"$ENVIRONMENT"/services/osman/terraform.tfstate auto_deploy_bucket_name | jq -r ".value")
	s3_upload

}

function deploy_active() {
	echo "Running active..."
	LAMBDA_FUNCTION=$(./terraform output -json -state=terraform-infrastructure/"$ENVIRONMENT"/services/rodin/v"$MAJOR_VERSION"/terraform.tfstate lambda_integrations | jq -r ".value.$ACTIVE_DEPLOYMENT")
	S3_DEPLOY_BUCKET=$(./terraform output -json -state=terraform-infrastructure/"$ENVIRONMENT"/services/osman/terraform.tfstate auto_deploy_bucket_name | jq -r ".value")
	s3_upload
}

function s3_upload() {

	echo "Zipping to $LAMBDA_FUNCTION.zip..."
	zip -qr "$LAMBDA_FUNCTION".zip * -x .git/\* -x composer.phar -x terraform-infrastructure/\* -x \*.zip -x .\* -x terraform
	echo "Uploading $LAMBDA_FUNCTION.zip to bucket $S3_DEPLOY_BUCKET..."
	aws s3 cp "$LAMBDA_FUNCTION".zip s3://"$S3_DEPLOY_BUCKET"/"$LAMBDA_FUNCTION".zip

	# Set output from last command
	if [ $? -eq 0 ];then
	   api_test
	else
	   echo "Upload to S3 failed!"
	   exit 1
	fi

}

function do_nothing() {
	echo "Nothing to do exit 1"
	exit 1
}

if [ "$ENVIRONMENT" == "dev" ]; then
	command
elif [ "$ENVIRONMENT" == "prd" ]; then
	command
else
	"Unknown environment: $ENVIRONMENT"
	exit 1
fi

if [ "$ACTIVE_DEPLOYMENT" == "blue" ]; then
	STAGING_DEPLOYMENT="green"
elif [ "$ENVIRONMENT" == "green" ]; then
	STAGING_DEPLOYMENT="blue"
fi

# Check for zero and set to 1 (version will probably be v0.5.0 until release
if [ "$MAJOR_VERSION" == "0" ]; then
	MAJOR_VERSION="1"
fi

echo "Environment: $ENVIRONMENT"
echo "Git comment: $GIT_COMMIT_DESC"
echo "Major version: $MAJOR_VERSION"
echo "Active deployment: $ACTIVE_DEPLOYMENT"
echo "Staging deployment: $STAGING_DEPLOYMENT"
echo "Deploy to: $DEPLOYMENT_ACTION"


case "$DEPLOYMENT_ACTION" in
"staging")
    deploy_staging
    ;;
"active")
    deploy_active
    ;;
*)
    do_nothing
    ;;
esac
