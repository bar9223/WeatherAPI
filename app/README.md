# WeatherAPI

1. Uruchamiamy linię komend w głównym folderze repozytorium i wykonujemy:

    

        * Wykonaj w folderze `./app`:

            ```
            docker-compose up -d
            ```


2. Następnie instalujemy Composera w tej samej lokalizacji `./app`:

    ```
    docker exec -it weather-php composer install
    ```

3. Następnie uruchamiamy plik z hostami:

    ```
    sudo nano /etc/hosts
    ```

    Dodajemy poniższa linikę:

    ```
    # WeatherAPI
    172.93.111.21   weather.lh
    ```

    Zapisujemy i zamykamy.

3. Następnie cofamy się do głównego katalogu i wykonujemy:

    ```
    cd ..
    yarn
    ```

## Uruchomienie

1. Uruchamiamy Dockera

    ```
    cd app
    docker-compose up -d
    ```

2. Odpalamy aplikację

    ```
    http://weather.lh/
    ```