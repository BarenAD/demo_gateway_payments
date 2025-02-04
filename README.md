<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Демонстрационный проект "Платёжный шлюз"

## Разработал: **[BarenAD](https://github.com/BarenAD)**
#### Проект в стадии разработки и тестирования, планы большие, но, возможно что-то уже вас заинтересует

### Функционал на данный момент: 

- **[Расчёт курса валют](https://github.com/BarenAD/demo_gateway_payments/blob/master/app/Services/CurrencyService.php)**
- **[Проведение транзакций, отложенных во времени](https://github.com/BarenAD/demo_gateway_payments/blob/master/app/Services/TransactionService.php)**
- **[[Client] Синхронизация валют со сторонним сервисом](https://github.com/BarenAD/demo_gateway_payments/blob/master/app/Clients/CurrencyCBRClient.php)**
- **[[Pattern: Factory] Расчёт баланса пользователя по транзакциям](https://github.com/BarenAD/demo_gateway_payments/blob/master/app/Services/Balances/UserBalanceCalculateHandles/UserBalanceCalculateHandle.php)**
- **[[Pattern: Factory] Сервис расчёта баланса](https://github.com/BarenAD/demo_gateway_payments/blob/master/app/Services/Balances/BalanceService.php)**
- **[[Model scope] [Model mutators] Переводы сущностей](https://github.com/BarenAD/demo_gateway_payments/blob/master/app/Models/ModelTranslations.php)**
- **[[Migration] Пример миграции](https://github.com/BarenAD/demo_gateway_payments/blob/master/database/migrations/2024_07_01_091937_create_transactions_table.php)**
- **[[Middleware] Пример миделвары](https://github.com/BarenAD/demo_gateway_payments/blob/master/app/Http/Middleware/SetLang.php)**
- **[[DTO] Пример DTO](https://github.com/BarenAD/demo_gateway_payments/blob/master/app/DTO/CurrencyDTO.php)**
- **[[Trait] Пример трейта](https://github.com/BarenAD/demo_gateway_payments/blob/master/app/Traits/EnumExtensionTrait.php)**
- **[[Helper] Пример хелпера](https://github.com/BarenAD/demo_gateway_payments/blob/master/app/Helpers/LangUtils.php)**

### План развития

- Настройка и поддержание работоспособности очереди (посредством супервизора)
- Добавление задач в очередь (посредством шедулера Laravel)
- Реализация автоматического деплоя
- Реализация тестов
- Реализация Swagger документации
- Упаковка проекта в Docker
- Кастомные эксепшены
- Реализация валидации прав доступа
- Настройка CI / CD
- Реализация пользовательского интерфейса (SPA на React) (будет возможность создавать имитацию пользователей, которые будут генерировать ассинхронно транзакции, а также отображение плана транзакций и их ход выполнения посредством сокетов или SSE)
