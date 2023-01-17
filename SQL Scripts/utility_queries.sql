-- ultima sessione
SELECT moto, t_lap, t_s1, t_s2, t_s3, t_s4 -- circuito
FROM tempo 
WHERE `data` >= ALL(
			SELECT `data`
            FROM tempo
            WHERE pilota = 'Lorenzo'
            AND circuito = 'Mugello Circuit'
        )
        AND pilota = 'Lorenzo'
		AND circuito = 'Mugello Circuit'
        -- limit 1
        ;
        
SELECT max(`data`) AS last_date
FROM tempo
WHERE pilota = "Lorenzo"
AND circuito = "Autodromo dell'Umbria";

-- migliori tempi di un utente per circuito e moto
SELECT moto, circuito, MIN(t_lap) AS best_lap
FROM tempo
WHERE pilota = 'Lorenzo'
		GROUP BY circuito, moto;

SELECT pilota, circuito, `data`, moto, MIN(t_lap) AS best_lap
	FROM tempo
	GROUP BY pilota, circuito;

-- classifica per circuito
SELECT RANK() OVER(PARTITION BY D.circuito ORDER BY D.best_lap) AS posizione, D.moto, D.pilota, D.`data`, D.best_lap
FROM(
	SELECT pilota, `data`, moto, circuito, MIN(t_lap) AS best_lap
	FROM tempo
	GROUP BY pilota, circuito
) AS D
WHERE D.circuito = "Autodromo dell'Umbria";

-- best mensile
SELECT D1.pilota, D1.moto, D1.best_lap
FROM (	
	SELECT RANK() OVER(PARTITION BY D.circuito ORDER BY D.best_lap) AS posizione, D.moto, D.pilota, D.`data`, D.best_lap
	FROM(
		SELECT pilota, `data`, moto, circuito, MIN(t_lap) AS best_lap
		FROM tempo
		GROUP BY pilota, circuito, moto
	) AS D
	WHERE D.circuito = "Autodromo dell'Umbria"
) AS D1
WHERE MONTH(D1.`data`) = MONTH(current_date())
LIMIT 1;

-- best annuale
SELECT D1.pilota, D1.moto, D1.best_lap
FROM (	
	SELECT RANK() OVER(PARTITION BY D.circuito ORDER BY D.best_lap) AS posizione, D.moto, D.pilota, D.`data`, D.best_lap
	FROM(
		SELECT pilota, `data`, moto, circuito, MIN(t_lap) AS best_lap
		FROM tempo
		GROUP BY pilota, circuito, moto
	) AS D
	WHERE D.circuito = "Mugello Circuit"
) AS D1
WHERE YEAR(D1.`data`) = YEAR(current_date())
LIMIT 1;

-- cambio password
UPDATE utente
SET `password` = 'foopsw'
WHERE username = 'Lorenzo';











