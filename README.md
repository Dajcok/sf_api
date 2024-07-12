
# Swift Feast API

Jednoduché RESTful API zamerané na správu objednávok v gastre. Primárnym účelom tohto API je správa položiek, objednávok a stolov v rámci reštaurácie, generovanie QR kódov pre jednotlivé stoly a platobné rozhranie pre jednotlivé objednávky.




## Inštalácia

Projekt je dockerizovaný a v `docker-compose.yaml` sú definované všetky potrebné závislosti.

```bash
  sudo docker-compose up -d --build
```

## Nastavenie prostredia .env

Aby sme mohli projekt úspešne spustiť, je potrebné vytvoriť `.env` súbor v zložke api/. Najjednoduchšie je skopírovať .env.example a prispôsobiť ho podľa potreby.

### Možné problémy
Je možné, že rôzne docker nastavenie na rôznych operačných systémoch budú generovať DNS mená jednotlivých služieb rozlične. DNS mená definované v súbore .env.example sú určené podľa mojej DNS docker siete, čiže je možné, že nebudú fungovať. Preto je potrebné skontrolovať reálne DNS meno kontajnera v rámci docker siete pomocou príkazu:

```bash
docker container ls
```
Problémové premenné môžu byť:

`REDIS_HOST`

`DB_HOST`


## Admin Rozhranie
Súčasťou aplikácie je aj backpack admin rozhranie dostupné na adrese:

```
GET /admin
```

### Prístup
Prístup do admin rozhrania je umožnený výlučne superuserom. Toho vytvoríme pomocou príkazu:
```bash
php artisan make:superuser <meno> <mail> <heslo>
```
## API Dokumentácia

Dokumentácia je generovaná pomocou Swagger a OpenAPI špecifikácie.

Dokumentácia je dostupná na adrese

```
  GET /api/documentation
```

#### Generovanie dokumentácie

```
  composer generate-swagger
```

#### Písanie dokumentácie

Telá požiadavok sa definujú v `Request` objektoch.

Schémy modelov definujeme v `Resource` objektoch.

Každá odpoveď musí byť obalená schémov `#/components/schemas/ApiResponse`

Každá listovacia odpoveď musí byť navyše obalená schémov `#/components/schemas/BaseCollection`
## Testovanie

Testy sú rozdelené na jednotkové(unit) a integračné(feature).

Unit testy sú plne mockované a nemajú žiadnu interakciu s databázou

Feature testy bežia nad testovaciou databázou, kt. sa vždy automaticky premigruje.

### Spustenie testov
Testy spúšťame pomocou `composer` príkazu, nakoľko len tam zabezpečím správne nastavenie testovacieho prostredia.

```bash
  composer test:unit
```

```bash
  composer test:feature
```


## Ostatné príkazy
Prečistenie konfigurácie:
```bash
composer recache
```

PHPCS + autofix:
```bash
composer lint
```

PHPStan:
```bash
composer inspect
```

Generovanie IDE Helpers:
```bash
composer generate-helpers
```