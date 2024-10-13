<?php

namespace PiSystems\Fakturownia\Enum\Invoice;

enum GtuCodes: string
{
    case GTU_01 = 'GTU_01'; // Dostawa napojów alkoholowych
    case GTU_02 = 'GTU_02'; // Dostawa towarów, o których mowa w art. 103 ust. 5aa ustawy
    case GTU_03 = 'GTU_03'; // Dostawa oleju opałowego i innych olejów smarowych
    case GTU_04 = 'GTU_04'; // Dostawa wyrobów tytoniowych, suszu tytoniowego itp.
    case GTU_05 = 'GTU_05'; // Dostawa odpadów (określonych w poz. 79-91 zał. nr 15 do ustawy)
    case GTU_06 = 'GTU_06'; // Dostawa urządzeń elektronicznych i części do nich
    case GTU_07 = 'GTU_07'; // Dostawa pojazdów oraz części samochodowych
    case GTU_08 = 'GTU_08'; // Dostawa metali szlachetnych oraz nieszlachetnych
    case GTU_09 = 'GTU_09'; // Dostawa leków oraz wyrobów medycznych
    case GTU_10 = 'GTU_10'; // Dostawa budynków, budowli i gruntów
    case GTU_11 = 'GTU_11'; // Świadczenie usług w zakresie przenoszenia uprawnień do emisji gazów cieplarnianych
    case GTU_12 = 'GTU_12'; // Świadczenie usług niematerialnych (doradczych, prawnych, księgowych itd.)
    case GTU_13 = 'GTU_13'; // Świadczenie usług transportowych i gospodarki magazynowej
}