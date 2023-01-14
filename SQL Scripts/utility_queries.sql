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

-- classifica per circuito
SELECT RANK() OVER(PARTITION BY D.circuito ORDER BY D.best_lap) AS posizione, D.moto, D.pilota, D.`data`,  D.circuito, D.best_lap, D.t_s1, D.t_s2, D.t_s3, D.t_s4
FROM(
	SELECT pilota, `data`, moto, circuito, MIN(t_lap) AS best_lap, t_s1, t_s2, t_s3, t_s4
	FROM tempo
	GROUP BY pilota, circuito, moto
) AS D
ORDER BY D.circuito;

-- classifica per circuito e moto
SELECT RANK() OVER(PARTITION BY D.moto, D.circuito ORDER BY D.best_lap) AS posizione, D.moto, D.pilota, D.`data`,  D.circuito, D.best_lap, D.t_s1, D.t_s2, D.t_s3, D.t_s4
FROM(
	SELECT pilota, `data`, moto, circuito, MIN(t_lap) AS best_lap, t_s1, t_s2, t_s3, t_s4
	FROM tempo
	GROUP BY pilota, circuito, moto
) AS D
ORDER BY D.circuito;

-- cambio password
UPDATE utente
SET `password` = 'foopsw'
WHERE username = 'Lorenzo';