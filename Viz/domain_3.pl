﻿kurs_de:- findall(X, de(X), All), write(All).
de_rel(C):- findall(X:Y-Z, rel(X,Y,Z), All), write(All).
de('Данные').
de('Базы данных').
de('СУБД').
de('Операции').
de('Банки данных').
de('Модели БД').
de('Знания').
rel('Базы данных','Данные',1).
rel('СУБД','Данные',0.9).
rel('СУБД','Операции',0.7).
rel('Операции','Базы данных',0.3).
rel('Банки данных','Данные',1).
rel('Модели БД','Базы данных',0.5).
rel('Знания','Данные',0.8).
