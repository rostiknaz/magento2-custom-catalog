# magento2-custom-catalog

## Installation (composer)

  * Install __Composer__ - [Composer Download Instructions](https://getcomposer.org/doc/00-intro.md) (if not installed)

  * Registering the module git repository

    ```sh
    $ composer config repositories.rostiknaz-magento2-custom-catalog git git@github.com:rostiknaz/magento2-custom-catalog.git
    ```
    Composer will register a new repository to composer.json (under “repositories” node). Updated composer.json looks like:
    
    ```
    {
      "repositories": {
        "rostiknaz-magento2-custom-catalog": {
          "type": "git",
          "url": "git@github.com:rostiknaz/magento2-custom-catalog.git"
        }
      }
    }
    ```  

  * Registering the module package itself
  
    ```
    $ composer require rostiknaz/magento2-custom-catalog:1.0.0
    ```
    This will add a new dependent package under node “require” and run installation process:
    
    ```
    {
      "require": {
        "rostiknaz/magento2-custom-catalog": "1.0.0"
      }
    }
    ```
  * Enable module
    
      ```
      $ php bin/magento setup:upgrade
      ```  
    
## Installation (manual)

  * Download the Module archive from github repo, unpack it and upload its contents to a new folder <root>/app/code/Rnazy/CustomCatalog/ of your Magento 2 installation
  * Enable module
  
    ```
    $ php bin/magento setup:upgrade
    ```
    
## Usage

  * Go to Admin panel and navigate to ``Catalog`` -> ``Custom Catalog``
  * There will be grid with listing all custom products, perform CRUD operations along with filtering and getting data on store view level.
  * Field 'Copywrite Info' has store view level, so the value can be different for each store views.
  * ACL rules is also in place, so you can restrict access to CRUD operations to any of admin user.
  
## Web Api`s

   * ``/V1/product/update`` - PUT -  perform update of custom product asynchronously (using RabbitMQ)
   
     Here is request body:
     ```
        {
            "entity_id": "9", //required field
            "copywrite_info": "555555555trtrtyt",
            "vpn": 1236
        }
     ```
     It validates ``entity_id`` field and check does product exist by this ID. IF validation passed it publish message to Rabbit MQ queue ``rnazy_product_update_queue`` in this format:
     ```
        {
            "store_id": "1", // depends on wep api store code in host/rest/<store_code>/V1/product/update
            "product": {
                "id": 9,
                "copywrite_info": "555555555trtrtyt",
                "vpn": 1236,
                "sku": 456
            }
        }
     ```
     To start consuming messages from this queue and perform async update, need to run this command:
     ```
     $ php bin/magento queue:consumers:start rnazy_product_entity_update
     ``` 
   
   * ``/V1/product/getByVPN/:vpn`` - GET - get list of all products filtered by VPN