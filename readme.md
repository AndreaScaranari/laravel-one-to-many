# Esercizio di oggi: Laravel Boolfolio - Project Typology
### Nome repo: laravel-one-to-many

Continuiamo a lavorare sul codice dei giorni scorsi, ma in una nuova repo e aggiungiamo una nuova entità Type.<br>
Questa entità rappresenta la tipologia di progetto ed è in relazione one to many con i progetti.<br>
I task da svolgere sono diversi, ma alcuni di essi sono un ripasso di ciò che abbiamo fatto nelle lezioni dei giorni
scorsi:
- creare il model Type
- creare la migration per la tabella types
- creare la migration di modifica per la tabella projects per aggiungere la chiave esterna
- aggiungere ai model Type e Project i metodi per definire la relazione one to many
- visualizzare nella pagina di dettaglio di un progetto la tipologia associata, se presente
- permettere all’utente di associare una tipologia nella pagina di creazione e modifica di un progetto
- gestire il salvataggio dell’associazione progetto-tipologia con opportune regole di validazione

### Bonus 1
Creare il seeder per il model Type.

### Bonus 2
Aggiungere le operazioni CRUD per il model Type, in modo da gestire le tipologie di progetto direttamente dal pannello
di amministrazione.