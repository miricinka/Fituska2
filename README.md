# Fituska2

Informační systém v PHP framework Symfony

url:https://fituska2.herokuapp.com/

Body: 30/30

## Zadani 

### Popis:
Úkolem zadání je vytvořit informační systém pro zlepšení přípravy studentů na zkoušky s prvky gamifikace. Smyslem je pokládat (jak studenty, tak vyučujícími) relevantní otázky k vybraným kurzům (předmětům), kde každá otázka má nějaké označení, pomocí které ji účastníci budou moci vhodně odlišit (název) a další atributy (popis, případné ilustrace, apod.). Zároveň má každá otázka přidělenou kategorii (např. kategorie: půlsemestrálka, zkouška, první cvičení). K položeným otázkám je možné vložit maximálně jednu textovou odpověď každým studentem kurzu (popis, případné ilustrace, apod.), jejichž obsah může být diskutována v diskusním vlákně odpovědi a její kvalita případně oceněna jinými studenty udělením hlasů. Správnost odpovědí je po vložení dostatečného množství odpovědí (posoudí vyučující) vyhodnocena vyučujícím kurzu a studentům správných odpovědí jsou v jejich profilu přičteny body, které získali od ostatních studentů. Uživatelé budou moci dále informační systém použít konkrétně následujícím způsobem:

### administrátor

spravuje uživatele

má rovněž práva všech následujících rolí

### moderátor

schvaluje kurzy (např. pro ověření, že dotyčný je vyučující kurzu)

má práva registrovaného uživatele

### registrovaný uživatel

zakládá kurz - stává se vyučujícím kurzu

schvaluje registrované studenty kurzu

spravuje kategorie otázek

pokládá otázky

nesmí reagovat na otázky (psát odpovědi)

uzavírá otázku

označí správné a špatné odpovědi (hlasy studentů u správných odpovědí se přičtou autorovi do profilu; správné odpovědi bez hlasů mohou rovněž dostat nějaké hlasy od vyučujícího - rozhodne vyučující hromadně)

napíše finální odpověď

registruje se na kurz - stává se studentem kurzu

pokládá otázky

píše odpovědi (každý student může vložit maximálně jednu odpověď ke každé otázce; nesmí vložit odpověď ke své otázce)

přidává reakce k odpovědím (libovolné množství)

uděluje hlasy odpovědím (každý student může udělit maximálně 3 hlasy u každé otázky)

### neregistrovaný

vidí zadané kurzy, otázky a odpovědi

vidí uživatele a jejich nasbírané hlasy (žebříčky pro kurzy a celkové)

má možnost procházet a vyhledávat v otázkách


