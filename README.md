# Fituska2

Information system in PHP framework Symfony

Points: 30/30

## Web application for teachers and students
The task is to create an information system to improve student exam preparation with gamification elements. The aim is to ask relevant questions about selected courses to both students and teachers, where each question has a title and other attributes. Each student in the course can provide a maximum of one textual answer to the posed questions. The content can be discussed in a discussion thread of the answer and its quality may be recognized by other students awarding votes. After a sufficient number of answers have been submitted, the correctness of the answers is evaluated by the course teacher, and students who have provided correct answers are awarded points.

Detailed description and user roles below.

- list of all courses available for students to enroll in
- teachers have the ability to create new courses
- any new course that is created needs to be approved first before it becomes available for students to enroll in.
<img width="1440" alt="image" src="https://user-images.githubusercontent.com/56356131/224374848-0dccdfa6-10cc-4355-b8f3-783d554ba722.png">

- detail of a course
- users can ask questions related to the course content
- the status of each question (i.e., whether it has been answered or is still open) is visible to users.
- each question is assigned to a specific category 

<img width="1440" alt="image" src="https://user-images.githubusercontent.com/56356131/224374944-1bc05949-02fc-4c01-b22d-049b9e236831.png">

- detail of a question
- users can 'like' and add comments to answers
<img width="1440" alt="image" src="https://user-images.githubusercontent.com/56356131/224375112-48993cc0-1958-4f8b-9c77-82b8220291c0.png">

- teacher can 'close' the question and provide a final answer
- correct answers by students are marked as correct and points are rewarded
<img width="1440" alt="image" src="https://user-images.githubusercontent.com/56356131/224375039-5fc89e47-75e9-4425-9633-56fbefd95f63.png">


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


