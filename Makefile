up:
	docker-compose up -d

down:
	docker-compose down

reset:	
	docker rmi quizload-quizload
	docker build -t quizload-quizload .

zerar:
	docker-compose down
	docker volume rm quizload_mysql-data
