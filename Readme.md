Pasos a seguir para la configuracion:
1. Clonar el repositorio
   ```git clone ...```
2. configurar el archivo .env
    ```cp.env   .env.local```
3. Instalar las dependencias
    ```docker compose up-d ```
    ``docker compose exec web bash```
    ```composer install```
4. cargar la base de datos
    ```mysql -u root -pdbrootpass -h add-dbms < db/spotify.sql```
