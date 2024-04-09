<!-- Pasos para despliegue en local
//===================================================================================================
        1.	Instalar xampp, Laragon, wampserver o de su preferencia para el despliegue del proyecto en local preferiblemente con php versión 7.4 o superior.
        2.	Clonar proyecto (git clone http://100.123.3.92/virtualizacion/asgardv8.1.git)
        3.	Tomar el archivo  .env y pegarlo en el directorio raíz del proyecto (https://indra365-my.sharepoint.com/personal/vdimbachi_indracompany_com/_layouts/15/onedrive.aspx?id=%2Fpersonal%2Fvdimbachi%5Findracompany%5Fcom%2FDocuments%2FRecursos%2Dasgard%2Flocal%2Denv&ga=1)
        4.	Obtener respaldo de bd asgard 
        5.	Configurar conexión bd local (localhost, puerto 3306, root, “”)
        6.	Crear database con nombre asgard8
        7.	Migrar la última actualización de la bd 
        8.	Verificar que se alcance la ip de ldap (en cmd ping 172.24.35.237)
        9.	Verificar que alcance la ip de ansible (en cmd ping 100.123.3.69)
        10.	Verificar que la extensión mbstring y ldap estén activas en laragon, xampp o lo que se esté utilizando, en el php.ini.
        11.	Instalación de Composer install
        12.	Desplegar asgard desde consola ejecutando el comando php artisan serve

        Gitlab http://100.123.3.92/users/sign_in
        virtualización Cl4r0@2020
        Ansible http://100.123.3.69/#/login  
        FrontSoporte 2021.S0p0rt3
//===================================================================================================

//===================================================================================================
Para ejecutar el script de inventarios realizamos los siguientes pasos: 
•	Ejecutar el script InsertInventoryAWX_Asgard.ps1
•	Si muestra el error de que no se tiene el module SimplySql se debe instalar con el siguiente comando:
•	Install-Module -Name SimplySql -RequiredVersion 1.6.2
•	Se debe crear un usuario nuevo en localhost 
•	Se crea con el siguiente comando: CREATE USER 'newuser'@'localhost' IDENTIFIED BY 'password';
•	Luego se le asignan los privilegios con el siguiente comando: GRANT ALL PRIVILEGES ON * . * TO 'newuser'@'localhost';
•	En la línea del script: 
	$connect = Open-MySqlConnection -Server "localhost" -Port 3306 -Database asgard8 -UserName colocarnuevousuario -Password "colocarnuevopassword" -ErrorAction Stop -WarningAction SilentlyContinue
	Reemplazar el nombre de usuario y password
•	Ejecutar el script
//===================================================================================================

  -->
