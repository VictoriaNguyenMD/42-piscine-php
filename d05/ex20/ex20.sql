SELECT film.id_genre, genre.name as 'name_genre', film.id_distrib, distrib.name as 'name_dstrib', film.title as 'title_film'
FROM film
INNER JOIN
	genre ON (film.id_genre = genre.id_genre) 
INNER JOIN 
	distrib ON (film.id_distrib = distrib.id_distrib)
WHERE 
	film.id_genre BETWEEN 4 AND 8;	
