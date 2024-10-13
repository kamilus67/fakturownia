<?php

namespace PiSystems\Fakturownia\Enum\Invoice;

enum DiscountKind: string
{
    case PERCENT_UNIT = 'percent_unit';               // liczony od ceny jednostkowej netto
    case PERCENT_UNIT_GROSS = 'percent_unit_gross';   // liczony od ceny jednostkowej brutto
    case PERCENT_TOTAL = 'percent_total';             // liczony od ceny całkowitej
    case AMOUNT = 'amount';                           // kwotowy
}