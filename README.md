# SQL Database Query Builder

This package as same as Laravel Query Builder, but it use Indonesian for those method name. Like "select()" to be "pilih()", "where()" to be "dimana()". So if you are not Indonesian, please translate on google translate before using this.

## Usage
```
class App {
    DB::tabel('users')
        ->pilih('name')
        ->dimana([
            ['city', '=', 'surabaya'],
            ['name], 'LIKE', '%riyan%']
        ])
        ->antara('age', ['0', '15'])
        ->urutkan([
            ['name', 'ASC],
            ['age', 'ASC']
        ])
        ->batasi(0, 10)
        ->jalankan();
}
```

## Note
This just building your SQL query and returning a string sql query. So it can't run query to your database server. It doesn't need sql server configuration