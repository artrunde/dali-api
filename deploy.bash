#!/bin/bash
git log --format=oneline -n 1 $1

# - zip -r $(./terraform output -state=terraform-infrastructure/dev/services/rodin/custom-domain-mapping/terraform.tfstate lambda_active).zip * -x .git/\* -x composer.phar -x terraform-infrastructure/\* -x \*.zip -x .\* -x terraform
#      - aws s3 cp $(./terraform output -state=terraform-infrastructure/dev/services/rodin/custom-domain-mapping/terraform.tfstate lambda_active).zip s3://$(./terraform output -state=terraform-infrastructure/dev/services/osman/terraform.tfstate auto_deploy_bucket_name)/$(./terraform output -state=terraform-infrastructure/dev/services/rodin/custom-domain-mapping/terraform.tfstate lambda_active).zip
#      - sleep 20 && ACTIVE_V1_URL=$(./terraform output -state=terraform-infrastructure/dev/services/rodin/custom-domain-mapping/terraform.tfstate active_v1_url) ./vendor/bin/phpunit
#
#

