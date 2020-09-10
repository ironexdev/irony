Doctrine commands

    php bin/doctrine.php orm:schema-tool:create/delete/update
    php bin/doctrine_fixtures.php

Request
    
    Query
    - associative arrays (objects) are not supported (only Query itself is an asssociative array)
    - associative and sequential arrays can only contain scalar types
    
    Body
    - arrays can only contain elements of one type
    
Mysql
   
    Select subtree
        select @pv:=id as id, name, parent_id from products
        join
        (select @pv:=490000)tmp
        where parent_id=@pv