# AFCTokenBundle

Generate key pair: 

```
openssl genrsa -out private.pem 2048
openssl rsa -in private.pem -outform PEM -pubout -out public.pem
```


##Install

1. **Add to composer**: `composer require path-to-repo/afc-tokens`

2. **Import**
 
 ```imports:
      - { resource: '{path-to-vendor}/vendor/path-to-repo/afc-tokens/src/Resources/config/services.yml' }
  ```
 
 
**or override services:**

```
	parameters:
	    aimchat.afct.param.secret: "%env(AFCT_SECRET)%"
	    aimchat.afct.param.public_file: "%env(AFCT_PUBLIC_PATH)%"
	    aimchat.afct.param.private_file: "%env(AFCT_PRIVATE_PATH)%"
	
	
	services:
	    _defaults:
	        autowire: false      # Automatically injects dependencies in your services.
	        autoconfigure: false # Automatically registers your services as commands, event subscribers, etc.
	        public: true         # this makes public all the services defined in this file
	
	
	    aimchat.afct.service:
	        class: Aimchat\AFCTokenBundle\Service\TokenService
	        arguments: []
	
	
	
	
	    aimchat.afct.key_public.file:
	        class: Aimchat\AFCTokenBundle\Service\CryptKey\FileKey
	        arguments: ["%aimchat.afct.param.public_file%"]
	
	    aimchat.afct.key_private.file:
	        class: Aimchat\AFCTokenBundle\Service\CryptKey\FileKey
	        arguments: ["%aimchat.afct.param.private_file%"]
	
	
	
	
	    aimchat.afct.serializer:
	        class: Aimchat\AFCTokenBundle\Service\TokenSerializerService
	        arguments: ["%aimchat.afct.param.secret%", "@aimchat.afct.key_private.file"]
	
	    aimchat.afct.deserializer:
	        class: Aimchat\AFCTokenBundle\Service\TokenDeserializerService
	        arguments: ["%aimchat.afct.param.secret%", "@aimchat.afct.key_public.file"]
```


3. **Add environments** (optional):


	```
	###> afct ###
	AFCT_SECRET=22b1cc6b49273b7816041eb7e39e9604
	AFCT_PUBLIC_PATH="path/to/public.key"
	AFCT_PRIVATE_PATH="path/to/private.key"
	###< afct ###
	```
  
  
   
4. **Extends controller** (optional):


	```
	class MyController extends TokenController
	{
		/**
		 * @return \Aimchat\AFCTokenBundle\TokenDeserializerInterface
		 */
		protected function getDeserializer(): TokenDeserializerInterface {
			return $this->get('aimchat.afct.deserializer');
		}
	
		/**
		 * @return \Aimchat\AFCTokenBundle\TokenServiceInterface
		 */
		protected function getTokenService(): TokenServiceInterface {
			return $this->get('aimchat.afct.service');
		}
		
		....
	}
	
	```