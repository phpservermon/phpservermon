tag = $(shell git describe)

help:
	@echo ' PHP Server Monitor - $(tag) '
	@echo ' - make export [tag=...]      - create a new release from tag '

export:
	@echo 'Building release for tag $(tag) '
	@echo 'Testing on syntax errors (thats all the automated testing your are going to get for now..) '
	find . -name "*.php" | xargs -I file php -l file
	rm -rf ./build
	mkdir ./build ./build/phpservermon
	git archive $(tag) | tar -xf - -C ./build/phpservermon/
	find ./build/phpservermon -name "*.php" -exec sed -i "" "s/@package_version@/$(tag)/" {} \;
	find ./build/phpservermon -type f | xargs chmod 0644
	find ./build/phpservermon -type d | xargs chmod 0755
	cd ./build; zip -rq phpservermon-$(tag).zip ./phpservermon; cd ../;
	cd ./build; tar -pczf phpservermon-$(tag).tar.gz ./phpservermon; cd ../;
	rm -rf ./build/phpservermon
	@echo 'Building release finished '
