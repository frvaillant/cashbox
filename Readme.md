# CASHBOX

Cashbox is a software to manage cash for little commercial entities

## Author
François VAILLANT

## Version
1.0 - BETA

## Stack
 - Symfony
 - Materialize css
 - Javascript
 
## License
MIT 

## requirements
PHP 7.4  
Mysql 
 
## How to install

Go in the folder where you want install CashBox
```
cd the_directory_where_you_want_to_install_cashbox
```

Download the project with 
```  
git clone https://github.com/frvaillant/cashbox
```

run the command
```
sh cashbox/install.sh
```
The script will ask you informations to set up your database 
and will run the necessary commands to setup CashBox. 
During the setup, you'll be asked for some caution about database.  
Don't worry, say 'y' to all questions.  

When install is done, go in the cashbox folder `cd cashbox` and run your server.  
*****
Enjoy :-)  
*****
CashBox comes with two users :

**Admin User**  
login : admin   
password : admin

**Simple User**  
login : user  
password : user  
*****************
**CAUTION**  
Please update the admin account before using CashBox (username AND password).
You also should remove the simple user account that is just created in order to test the application.






