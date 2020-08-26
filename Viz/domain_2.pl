kurs_de:- findall(X, de(X), All), write(All).
de_rel(C):- findall(X:Y-Z, rel(X,Y,Z), All), write(All).
de('Базы данных').
de('СУБД').
de('Декларация').
rel('СУБД','Базы данных',1).
rel('Декларация','Базы данных',0.2).
