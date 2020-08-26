﻿kurs_de:- findall(X, de(X), All), write(All).
de_rel(C):- findall(X:Y-Z, rel(X,Y,Z), All), write(All).
de('Сигнал').
de('Алиасинг').
de('АЦП').
de('Дискретизация').
de('Квантование ').
de('Телевизионные стандарты').
de('Цветовые пространства').
de('Сжатие данных').
de('Кодирование').
de('Кодек').
de('Контейнер').
de('Временная модель').
rel('Алиасинг','АЦП',0.7).
rel('АЦП','Сигнал',1).
rel('Квантование ','Сигнал',1).
rel('Телевизионные стандарты','АЦП',0.4).
rel('Цветовые пространства','Телевизионные стандарты',0.7).
rel('Кодирование','Сигнал',1).
rel('Кодирование','Дискретизация',0.6).
rel('Кодирование','Сжатие данных',0.4).
rel('Кодек','Кодирование',1).
rel('Контейнер','Дискретизация',0.5).
rel('Контейнер','Сжатие данных',0.8).
rel('Временная модель','Кодек',1).
rel('Сигнал','Дискретизация',).
