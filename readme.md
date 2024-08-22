# Normalux.ch

The best way to see what this project is to try it by yourself. It only takes 45 seconds.

https://www.normalux.ch/

## Getting Started

### Prerequisites

- PHP 7.4 (PHP ⩾8.0 is not compatible yet)
- MySQL

### Installing

- Clone the repository and copy config files:

```bash
git clone https://github.com/BurkhalterY/normalux.ch.git
cd normalux.ch/application/config/
cp config.php.sample config.php
cp database.php.sample database.php
```

- Edit `database.php` with your MySQL credentials.
- Manually create the database and import `database/normalux.sql` into it.

You can use an all-in-one solution such as XAMPP or UwAmp to run this project. Alternatively, you can use the following command in the repository root: `php7.4 -S 0.0.0.0:8000`.

## Built With

- [CodeIgniter 3](https://codeigniter.com/userguide3/) - the PHP framework

## Contributing

This project is not actively maintained, but feel free to contribute. I'll read all issues and PR.

## Acknowledgments

- Pokédraw - A similar website belonging to the past. The original idea come from there.
