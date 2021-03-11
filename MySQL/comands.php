<?php 
/*	
Документация phpMyAdmin
 https:// docs/phpmyadmin .net. 

Подробные сведения обо всех доступных строковых функциях 
и функциях даты и времени можно найти по следующим адресам:  
http://tinyurl.com/mysqlstrfuncs;  
http://tinyurl.com/mysqldatefuncs.

----SELECT
		Команда извлечения данных из таблицы
		SELECT author,title FROM classics

----SELECT COUNT 
		// (*) - все строки
		SELECT COUNT(*) FROM classics; 

----SELECT DISTINCT 
		 позволяет исключать множество записей, имеющих одинаковые данные.
		(вывести всех авторов, не повторяя их, даже если у них по несколько книг)
		SELECT DISTINCT author FROM classics

----DELETE
		Удаляет строку, где присутствует  title
		DELETE FROM classics WHERE title='Little Dorrit';

----WHERE
		 WHERE cужает диапазон действия запроса, возвращая только те данные, 
		 				в отношении которых конкретное выражение возвращает истинное значение
		SELECT author,title FROM classics WHERE author="Mark Twain"; 
		SELECT author,title FROM classics WHERE isbn="9781598184891 "; 
		
----LIKE
		word% - Что-нибудь следует После
		%word - Что-нибудь было ДО
		%word% - Что-нибудь ДО и ПОСЛЕ
		SELECT author,title FROM classics WHERE author LIKE "Charles%"; 
		SELECT author,title FROM classics WHERE title LIKE "%Species"; 
		SELECT author,title FROM classics WHERE title LIKE "%and%"

----LIMIT
		LIMIT кол-во выбрать, строка с который нужно начать
		SELECT author,title FROM classics LIMIT 3; 
		SELECT author,title FROM classics LIMIT 1,2;

----MATCH...AGAINST ------------------------------------------------------------------------
		
		Позволяет вводить в поисковый запрос несколько слов 
		и проверять на их наличие все слова в столбцах, имеющих индекс FULLTEXT.
		
		! Поиск любой комбинации искомых слов, НЕ ТРЕБУЯ наличия ВСЕХ этих слов в тексте
		
		Стоп слова будует игнорироваться (and, a, at,...)
		Двойные кавычки отменяют правила не использования стоп слов ("at")

		SELECT author,title FROM classics WHERE 
		MATCH(author,title) AGAINST('and'); 			//Empty set (тк end - игнорируется)
		
		SELECT author,title FROM classics WHERE
		MATCH(author,title) AGAINST('curiosity shop'); 
		
		SELECT author,title FROM classics WHERE 
		MATCH(author,title) AGAINST('tom sawyer');
		
----MATCH...AGAINST...IN BOOLEAN MODE---------------------------------------------------------------
		+Вернуть, если слово пристутствует
		-Исключение любой строки, где ест это слово

		SELECT author,title FROM classics WHERE 
		MATCH(author,title) AGAINST('+charles -species' IN BOOLEAN MODE); 

		SELECT author,title FROM classics WHERE 
		MATCH(author,title) AGAINST('"origin of"' IN BOOLEAN MODE);

----UPDATE...SET-------------------------------------------------------------------------------------
		Обновление содеримого поля

		UPDATE classics SET author='Mark Twain (Samuel Langhorne Clemens)' 
		WHERE author='Mark Twain'; 

		UPDATE classics SET category='Classic Fiction' 
		WHERE category='Fiction';

----ORDER BY 
 		Позволяет отсортировать возвращаемые результаты по одному или нескольким столбцам
		SELECT author,title FROM classics 
		ORDER BY author; 

		SELECT author,title FROM classics 
		ORDER BY title DESC;							// убывающий порядок

// По автору, потом в убывающем по годам
		SELECT author,title,year FROM classics 
		ORDER BY author,year DESC; 			
// ИЛИ (явный вид возр по автору)
		SELECT author,title,year FROM classics 
		ORDER BY author ASC,year DESC; 		

----GROUP BY 
		Группировка

		SELECT category,COUNT(author) FROM classics
		 GROUP BY category;

----Объединение таблиц-----------------------------------------------------------------------------
Рассмотрим, к примеру, таблицу клиентов — customers, для которой нужно обеспечить возможность использования перекрестных ссылок с приобретенными ими книгами из таблицы classics. 
ISBN - ССЫЛКА НА ОДНУ И ТУ ЖЕ КНИГУ

		CREATE TABLE customers ( 
		name VARCHAR(128), 
		isbn VARCHAR(13), 
		PRIMARY KEY (isbn)) ENGINE MyISAM; 

		INSERT INTO customers(name,isbn) 
			VALUES('Joe Bloggs','9780099533474'); 
		INSERT INTO customers(name,isbn) 
			VALUES('Mary Smith','9780582506206'); 
		INSERT INTO customers(name,isbn) 
			VALUES('Jack Wilson','9780517123201'); 
// ИЛИ 
		INSERT INTO customers(name,isbn) 
		VALUES ('Joe Bloggs','9780099533474'), 
					 ('Mary Smith','9780582506206'), 
					 ('Jack Wilson','9780517123201');
//					 
		SELECT * FROM customers;

  Выведем все книги, которые есть у ВЛАДЕЛЬЦЕВ (name)
			SELECT name,author,title  
			FROM customers,classics 
			WHERE customers.isbn=classics.isbn

----NATURAL JOIN ----
		 В этом виде объединения участвуют две таблицы, в которых автоматически объединяются столбцы с одинаковыми именами.
		Результат такой же как у Объединения таблиц

		SELECT name,author,title 
		FROM customers NATURAL JOIN classics;

----JOIN...ON-----
		Если нужно указать столбец, по которому следует объединить две таблицы, 
		используется конструкция JOIN...ON, 
		благодаря которой можно получить те же результаты, 
		что и в примере Объединения таблиц
		
		SELECT name,author,title FROM customers 
		JOIN classics ON customers.isbn=classics.isbn; 

----Использование ключевого слова AS----
		Создание псевдонимов с исп AS (улучшает читаемость при длинных запросах)

		SELECT name,author,title FROM 
		customers AS cust, 
		classics AS class 
		WHERE cust.isbn=class.isbn; 

-----Логические Операторы-------------------------------------------------------------------------------------------------------------------
	 	AND OR NOT

		SELECT author,title FROM classics 
		WHERE author LIKE "Charles%" AND author LIKE "%Darwin"; 

		SELECT author,title FROM classics 
		WHERE author LIKE "%Mark Twain%" OR author LIKE "%Samuel Langhorne Clemens%"; 

		SELECT author,title FROM classics 
		WHERE author LIKE "Charles%" AND author NOT LIKE "%Darwin";
*/
 ?>