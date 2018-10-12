#language: pl

  Potrzeba biznesowa: Jako pracownik firmy pożyczkowej
    chciałbym aby łatwo móc wyliczyć saldo dla bilansu pożyczki dla konrketnego dnia
    biorąc pod uwagę obciążenia za kapitał, prowizje oraz odsetki kapitałowe
    oraz wszekie uzanania wpłacone przez klienta

  Założenia:
    Zakładając że obłsugujemy tylko następującą kolejność rozliczeń:
      | Odsetki kapitałowe |
      | Prowizja           |
      | Kapitał            |
    Oraz że klient złożył wniosek po pożyczkę na 1700zł z prowizją 466,65zł gdzie wysokość dziennych odsetek wynosi 0,45zł

  Scenariusz: Kalkulacja salda bilansu pożyczki wpłacie kwoty 3 dnia
    Gdy klient wpłaci 1000zł 3 dnia pożyczki
    Wtedy saldo bilansu pożyczki dla klienta na dzień 2 wynosić będzie 2167,55zł
    Oraz saldo bilansu pożyczki dla klienta na dzień 3 wynosić będzie 1168zł
    Oraz saldo bilansu pożyczki dla klienta na dzień 1 wynosić będzie 2167,10zł
