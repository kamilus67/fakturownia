<?php

namespace PiSystems\Fakturownia\Enum\Invoice;

enum PaymentType: string
{
    case TRANSFER = 'transfer';                         // przelew
    case CARD = 'card';                                 // karta płatnicza
    case CASH = 'cash';                                 // gotówka
    case BARTER = 'barter';                             // barter
    case CHEQUE = 'cheque';                             // czek
    case BILL_OF_EXCHANGE = 'bill_of_exchange';         // weksel
    case CASH_ON_DELIVERY = 'cash_on_delivery';         // opłata za pobraniem
    case COMPENSATION = 'compensation';                 // kompensata
    case LETTER_OF_CREDIT = 'letter_of_credit';         // akredytywa
    case PAYU = 'payu';                                 // PayU
    case PAYPAL = 'paypal';                             // PayPal
    case OFF = 'off';                                   // nie wyświetlaj
}