# Introduction

This is an example Symfony project for [Feater](https://github.com/boldare/feater).

# Usage with Feater

1. Create a project in Feater.
1. Add an asset with MySQL sample data using file `test_db_volume_asset.tar.gz` you can find [here](https://www.dropbox.com/s/ke1dlq8ck8g3ahv/test_db_volume_asset.tar.gz). Its ID should be set to `test_db_volume`.
1. Add an asset with Elasticsearch sample data using file `test_elasticsearch_volume_asset.tar.gz` you can find [here](https://www.dropbox.com/s/mo3735mp7rq2031/test_elasticsearch_volume_asset.tar.gz?dl=0). Its ID should be set to `test_elasticsearch_volume`.
1. Add a definition using a recipe provided [here](https://github.com/boldare/feater-symfony-example/blob/master/.feater/recipe.yml).
1. Now you can create any number of instances using the definition.
