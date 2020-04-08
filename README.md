# AFCTokenBundle

Generate key pair: 

```
openssl genrsa -out private.pem 2048
openssl rsa -in private.pem -outform PEM -pubout -out public.pem
```


##Install

1. **Add to composer**: `composer require umbrella-evgeny-nefedkin/afc-tokens`

2. **Import**
 
 ```imports:
      - { resource: '{path-to-vendor}/vendor/umbrella-evgeny-nefedkin/afc-tokens/src/Resources/config/services.yml' }
  ```
 
 
**or override services:**

```
	parameters:
	    umbrella.afct.param.secret: "%env(AFCT_SECRET)%"
	    umbrella.afct.param.public_file: "%env(AFCT_PUBLIC_PATH)%"
	    umbrella.afct.param.private_file: "%env(AFCT_PRIVATE_PATH)%"
	
	
	services:
	    _defaults:
	        autowire: false      # Automatically injects dependencies in your services.
	        autoconfigure: false # Automatically registers your services as commands, event subscribers, etc.
	        public: true         # this makes public all the services defined in this file
	
	
	    umbrella.afct.service:
	        class: Umbrella\AFCTokenBundle\Service\TokenService
	        arguments: []
	
	
	
	
	    umbrella.afct.key_public.file:
	        class: Umbrella\AFCTokenBundle\Service\CryptKey\FileKey
	        arguments: ["%umbrella.afct.param.public_file%"]
	
	    umbrella.afct.key_private.file:
	        class: Umbrella\AFCTokenBundle\Service\CryptKey\FileKey
	        arguments: ["%umbrella.afct.param.private_file%"]
	
	
	
	
	    umbrella.afct.serializer:
	        class: Umbrella\AFCTokenBundle\Service\TokenSerializerService
	        arguments: ["%umbrella.afct.param.secret%", "@umbrella.afct.key_private.file"]
	
	    umbrella.afct.deserializer:
	        class: Umbrella\AFCTokenBundle\Service\TokenDeserializerService
	        arguments: ["%umbrella.afct.param.secret%", "@umbrella.afct.key_public.file"]
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
		 * @return \AFCTokenBundle\TokenDeserializerInterface
		 */
		protected function getDeserializer(): TokenDeserializerInterface {
			return $this->get('umbrella.afct.deserializer');
		}
	
		/**
		 * @return \AFCTokenBundle\TokenServiceInterface
		 */
		protected function getTokenService(): TokenServiceInterface {
			return $this->get('umbrella.afct.service');
		}
		
		....
	}
	
	```