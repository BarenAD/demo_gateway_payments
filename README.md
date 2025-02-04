<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Демонстрационный проект "Платёжный шлюз"

## Разработал: **[BareAD](https://github.com/BarenAD)**
#### Проект в стадии разработки и тестирования, планы большие, но, возможно что-то уже вас заинтересует

### Функционал на данный момент: 

- **[[By Laravel Client] Синхронизация валют со сторонним сервисом](https://github.com/BarenAD/demo_gateway_payments/blob/master/app/Clients/CurrencyCBRClient.php)**
- **[Расчёт курса валют](https://github.com/BarenAD/demo_gateway_payments/blob/master/app/Services/CurrencyService.php)**
- **[[Pattern: Factory] Расчёт баланса пользователя по транзакциям](https://github.com/BarenAD/demo_gateway_payments/blob/master/app/Services/Balances/BalanceService.php)**
- **[Проведение транзакций, отложенных во времени](https://github.com/BarenAD/demo_gateway_payments/blob/master/app/Services/TransactionService.php)**
- **[[Model scope] [Model mutators] Переводы сущностей](https://github.com/BarenAD/demo_gateway_payments/blob/master/app/Models/ModelTranslations.php)**

### План развития

- Настройка и поддержание работоспособности очереди (посредством супервизора)
- Добавление задач в очередь (посредством шедулера Laravel)
- Реализация автоматического деплоя
- Реализация тестов
- Упаковка проекта в Docker
- Настройка CI / CD
- Реализация пользовательского интерфейса (SPA на React) (будет возможность создавать имитацию пользователей, которые будут генерировать ассинхронно транзакции, а также отображение плана транзакций и их ход выполнения посредством, скорее всего сокетов или SSE)
