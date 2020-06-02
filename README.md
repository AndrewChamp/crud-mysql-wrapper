C.R.U.D. MySQL Wrapper
==================

Create, Read, Update, Delete wrapper for MySQL connections. Simpler and easier to use class using PDO & Singleton pattern for simplifying redundant MySQL connections and queries.

## How To Use

### Instantiating the Class
```php	
$crud = crud::obtain('localhost', 'databaseUsername', 'databasePassword', 'databaseName');
```

### Reading Table
```php
$result = $crud->query("SELECT * FROM your_table");
print_r($result);
```

### Inserting new data in a table
```php
$data['firstname'] = 'Jack';
$data['lastname'] = 'Jones';
$crud->insert('your_table', $data);
```

### Updating data
```php
$data['firstname'] = 'Joe';
$data['lastname'] = 'Mama';
$crud->update('your_table', $data, 'user_id=4');
```

### Deleting row
```php
$crud->delete('your_table', 'id=123');
```

### Truncate table
*Empties all data from the table.*
```php
$crud->truncate('your_table');
```

### Drop table
*Completely deletes the table.*
```php
$crud->drop('your_table');
```
