LRR User Documentation
======================


Resetting password
-------------------

We can reset a user's password by directly modifying the MySQL database table called `users_table`.  More specifically, we delete that user's information from `users_table` so that the user could sign up again.  Suppose the user's student number is 201131129138.

To do so, LRR administrator logs in to MySQL using the following command:  `mysql -u username -p`.  Type the correct password to access the MySQL database.

After that, issue the following commands in the mysql prompt.

- `use lrr;`

- `delete from users_table where Student_ID="201131129138";`

The first one uses a database called lrr in MySQL.  The second one deletes a record from `users_table` where the student number is 201131129138.

Increasing session duration
-------------------

By default, the session duration in PHP is set to 1,440 seconds (24 minutes). However, this is not convenient in most software systems. Therefore, we may need to increase the duration to allow users to have more session time. To increase the session duration, we need to edit the variable *session.gc_maxlifetime* in **php.ini**. We can increase its default value to whatever we want (e.g., 7200).
On Ubuntu, the file is located at */etc/php/7.2/apache2/php.ini*. On XAMPP, the file is located at */xampp/php/php.ini*.

*Last modified on 20 April 2022 by Umar*
