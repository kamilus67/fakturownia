<?php

namespace PiSystems\Fakturownia\Enum\Invoice;

enum Kind: string
{
    case VAT = 'vat';                            // faktura VAT
    case PROFORMA = 'proforma';                  // faktura Proforma
    case BILL = 'bill';                          // rachunek
    case RECEIPT = 'receipt';                    // paragon
    case ADVANCE = 'advance';                    // faktura zaliczkowa
    case FINAL = 'final';                        // faktura końcowa
    case CORRECTION = 'correction';              // faktura korekta
    case VAT_MP = 'vat_mp';                      // faktura MP
    case INVOICE_OTHER = 'invoice_other';        // inna faktura
    case VAT_MARGIN = 'vat_margin';              // faktura marża
    case KP = 'kp';                              // kasa przyjmie
    case KW = 'kw';                              // kasa wyda
    case ESTIMATE = 'estimate';                  // zamówienie
    case VAT_RR = 'vat_rr';                      // faktura RR
    case CORRECTION_NOTE = 'correction_note';    // nota korygująca
    case ACCOUNTING_NOTE = 'accounting_note';    // nota księgowa
    case CLIENT_ORDER = 'client_order';          // własny dokument nieksięgowy
    case DW = 'dw';                              // dowód wewnętrzny
    case WNT = 'wnt';                            // Wewnątrzwspólnotowe Nabycie Towarów
    case WDT = 'wdt';                            // Wewnątrzwspólnotowa Dostawa Towarów
    case IMPORT_SERVICE = 'import_service';      // import usług
    case IMPORT_SERVICE_EU = 'import_service_eu'; // import usług z UE
    case IMPORT_PRODUCTS = 'import_products';    // import towarów - procedura uproszczona
    case EXPORT_PRODUCTS = 'export_products';    // eksport towarów
}