# Refactoring test

The aim of this test is to refactor a project written in PHP programming language. The final target is a clear well structured
solution to make the project easy to manipulate, understand and deploy.

### Cloning
Clone or donwload 
```
git clone https://github.com/khouloudS/refactoring.git
```


### Solution breakdown
The original project has been divided into a clear structure using the necessary refactoring strategy. Below is the folders architecture of the final refactored project:


						├───app
						│   ├───config
						│   ├───Sale
						│   │   ├───interface
						│   │   ├───model
						│   │   └───service
						│   ├───System
						│   │   ├───interface
						│   │   └───model
						│   ├───Transaction
						│   │   ├───interface
						│   │   ├───models
						│   │   └───service
						│   ├───User
						│   │   ├───interface
						│   │   ├───model
						│   │   └───service
						│   └───utils
						├───assets
						│   ├───bootstrap
						│   └───styleSheet
						├───vendor
						└───views


##### 1. app folder

In this folder, the project has been divided into modules: Sale, System, Transaction and User.
 
**System** implements the global functionnalities.
**Sale** module is designed to implement all sales functionnalities for this application.
**Transaction** module implements all the transaction related routines.
**User** module is created for scalability purposes: In case users will be added to the application. Also,the Admin class inherits from the User class.
**Utils** contains the environment variable declarations as well as all the routines calling html components.
**config** stores the provided configuration files.

Usually, under each module we have a set of three folders (except for System) for the following purposes:
	**model** contains the object class definition (depending on the module in question: Sale, Transcation or User).
	**interface** is used to list functions related to the object.
	**services** contains the actual implementation of functions previously defined in the corresponding interface subfolder.


##### 2. assets folder
In this folder we list all the syte files. To do so, we add two main subfolders:

**bootstrap** where the twig template locations are specified and our twig is instantiated.
**stylesheet** contains the CSS files.

##### 3. vendor folder:

Contains the twig autloader.

##### 4. views folder:

Contains the html files including **layout.html** where all the html skeletons have been defined.

### Author
Khouloud Sellami (khouloud.sellami@esprit.tn)