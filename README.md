Doctrine commands

    php vendor/doctrine/orm/bin/doctrine.php orm:schema-tool:create
    php vendor/doctrine/orm/bin/doctrine.php orm:schema-tool:update

Request
    
    Query
    - associative arrays (objects) are not supported (only Query itself is an asssociative array)
    - associative and sequential arrays can only contain scalar types
    
    Body
    - arrays can only contain elements of one type