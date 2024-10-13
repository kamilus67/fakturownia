<?php

namespace PiSystems\Fakturownia\Enum\Invoice;

enum AccountingKind: string
{
    case PURCHASES = 'purchases';                     // Zakup towarów i materiałów
    case EXPENSES = 'expenses';                       // Koszty prowadzenia działalności
    case MEDIA = 'media';                             // Media i usługi telekomunikacyjne
    case SALARY = 'salary';                           // Wynagrodzenia
    case INCIDENT = 'incident';                       // Koszty uboczne zakupu
    case FUEL_0 = 'fuel0';                            // Zakup paliwa do pojazdów 0%
    case FUEL_EXPL_75 = 'fuel_expl75';                // Zakup paliwa i eksploatacja pojazdu 75%
    case FUEL_EXPL_100 = 'fuel_expl100';              // Zakup paliwa i eksploatacja pojazdu 100%
    case FIXED_ASSETS = 'fixed_assets';               // Środki trwałe
    case FIXED_ASSETS_50 = 'fixed_assets50';          // Środki trwałe 50%
    case NO_VAT_DEDUCTION = 'no_vat_deduction';       // Bez możliwości odliczenia podatku VAT
}