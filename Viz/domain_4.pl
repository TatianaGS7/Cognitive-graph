﻿kurs_de:- findall(X, de(X), All), write(All).
de_rel(C):- findall(X:Y-Z, rel(X,Y,Z), All), write(All).
de('Электронное издание').
de('Гипертекстовый документ').
de('Электронные библиотеки').
de('Электронный документ').
de('Электронные книги').
de('Формат PDF').
de('Формат DjVu').
de('Формат RTF').
de('Форматы электронных документов').
de('Система верстки TeX').
de('Электронные чернила').
de('Языки разметки HTML и XML').
de('Формат FictionBook').
rel('Электронные библиотеки','Электронное издание',1).
rel('Языки разметки HTML и XML','Гипертекстовый документ',0.6).
rel('Электронные книги','Электронный документ',1).
rel('Форматы электронных документов','Электронный документ',1).
rel('Система верстки TeX','Электронный документ',0.9).
rel('Электронное издание','Электронный документ',0.8).
rel('Гипертекстовый документ','Электронный документ',0.8).
rel('Электронные чернила','Электронные книги',0.5).
rel('Формат FictionBook','Электронные книги',0.5).
rel('Формат DjVu','Форматы электронных документов',0.7).
rel('Формат RTF','Форматы электронных документов',0.7).
rel('Формат PDF','Форматы электронных документов',0.7).
rel('Форматы электронных документов','Языки разметки HTML и XML',0.8).