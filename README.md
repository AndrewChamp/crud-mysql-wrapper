C.R.U.D. MySQL Wrapper
==================

Create, Read, Update, Delete wrapper for MySQL.  Simple, easy to use class using PDO for simplifing redundant MySQL connections and methods.

## How To Use

### Instantiating the Class
```php	
$crud = crud::obtain('localhost', 'databaseUsername', 'databasePassword', 'databaseName');
```

### Reading Table
```php
$result = $crud->query("SELECT * FROM table");
print_r($result);
```

### Inserting new data in a table
```php
$data['firstname'] = 'Jack';
$data['lastname'] = 'Jones';
$crud->insert('users', $data);
```

### Updating data
```php
$data['firstname'] = 'Joe';
$data['lastname'] = 'Mama';
$crud->update('users', $data, 'user_id=4');
```

### Deleting data
```php
$crud->delete('users', 'user_id=1');
```
