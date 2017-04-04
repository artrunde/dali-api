#!/bin/bash
GIT_COMMIT_DESC=$(git log --format=oneline -n 1 $1)
ENVIRONMENT=$2

# - zip -r $(./terraform output -state=terraform-infrastructure/dev/services/rodin/custom-domain-mapping/terraform.tfstate lambda_active).zip * -x .git/\* -x composer.phar -x terraform-infrastructure/\* -x \*.zip -x .\* -x terraform
#      - aws s3 cp $(./terraform output -state=terraform-infrastructure/dev/services/rodin/custom-domain-mapping/terraform.tfstate lambda_active).zip s3://$(./terraform output -state=terraform-infrastructure/dev/services/osman/terraform.tfstate auto_deploy_bucket_name)/$(./terraform output -state=terraform-infrastructure/dev/services/rodin/custom-domain-mapping/terraform.tfstate lambda_active).zip
#      - sleep 20 && ACTIVE_V1_URL=$(./terraform output -state=terraform-infrastructure/dev/services/rodin/custom-domain-mapping/terraform.tfstate active_v1_url) ./vendor/bin/phpunit
#
#

function command() {

	if [[ "$GIT_COMMIT_DESC" == *"[deploy=staging]"* ]]; then
	  echo "It's there staging!"
	fi

	if [[ "$GIT_COMMIT_DESC" == *"[deploy=new]"* ]]; then
	  echo "It's there new!"
	fi

	if [[ "$GIT_COMMIT_DESC" == *"[deploy=active]"* ]]; then
	  echo "It's there active!"
	fi

}

function dev() {
	echo "dev"
}

function prd() {
	echo "prd"
}

# "Bla bla [deploy=staging]" "Bla bla [deploy=new]" "Bla bla [deploy=active]"
echo $ENVIRONMENT
echo $GIT_COMMIT_DESC

if [ "$ENVIRONMENT" == "dev" ]; then
	dev
elif [ "$ENVIRONMENT" == "prd" ]; then
	prd
fi

