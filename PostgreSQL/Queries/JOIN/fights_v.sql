CREATE OR REPLACE VIEW flights_v AS
	SELECT f.flight_id,
				 f.flight_no,
				 
				 f.scheduled_departure,
				 timezone( dep.timezone, f.scheduled_departure )
				 	AS scheduled_departure_local,
				 
				 f.scheduled_arrival,
				 timezone( arr.timezone, f.scheduled_arrival )
				 	AS scheduled_arrival_local,
				 
				 f.scheduled_arrival - f.scheduled_departure AS scheduled_duration,
				 
				 f.departure_airport,
				 dep.airport_name AS departure_airport_name,
				 dep.city AS departure_city,

				 f.arrival_airport,
				 arr.airport_name AS arrival_airport_name,
				 arr.city AS arrival_city,

				 f.status,
				 f.aircraft_code,
				 
				 f.actual_departure,
				 timezone( dep.timezone, f.actual_departure )
				 	AS actual_departure_local,

				 f.actual_arrival,
				 timezone( arr.timezone, f.actual_arrival )
				 	AS acrual_arrival_local,

				 	f.actual_arrival - f.actual_departure AS actual_duration
		FROM flights f,
				 --- dep и arr
				 --- Нужны для того, чтобы отдельно получить аэропорты вылета и прилета
				 --- Иначе при выполнении AND он будет принимать вылет и прилет в 1 город.
				 --- При разделении на 2 запроса поиск будет производиться дважды:
				 --- Для Аэропорта отправления и прибытия
				 airports dep,
				 airports arr
	 WHERE f.departure_airport = dep.airport_code
	 	 AND f.arrival_airport = arr.airport_code
