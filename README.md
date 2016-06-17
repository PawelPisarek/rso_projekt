rso_projekt
===========

1 composer install

2 tworzymy nowy plik parameters YML w folderze config taki sam jak przy instalacji symfony2

3 redis-server <- uruchamia baze danych redis

4 php bin/console s:r <- powinno zwrócić działający projekt symfony2

5 jeśli nie działa to jeszcze polecenia

 a) php bin/console d:d:c <-tworzy bazę danych
 
 b) php bin/console d:s:c <- tworzy schemat bazy dancyh
 
 http://localhost:15672 <-jakiś panel administracyjny rabitmq
 
 php bin/console rabbitmq:c sample --route="sample" <- wypisanie tego co jest w kolejece
 
 sudo rabbitmqctl stop_app <- gdy pobierzemy więcej wiadomości niż jest w kolejce
