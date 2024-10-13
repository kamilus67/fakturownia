<?php

namespace PiSystems\Fakturownia\Enum\Invoice;

enum Status: string
{
    case ISSUED = 'issued';       // wystawiona
    case SENT = 'sent';           // wysłana
    case PAID = 'paid';           // opłacona
    case PARTIAL = 'partial';     // częściowo opłacona
    case REJECTED = 'rejected';   // odrzucona
}