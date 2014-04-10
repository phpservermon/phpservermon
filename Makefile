tag = $(shell git describe)

help:
	@echo ' PHP Server Monitor - $(tag) '
	@echo ' - make export [tag=...]      - create a new release from tag '

export:
	@echo 'Building release for tag $(tag) '
	mkdir -p ./build ./build/phpservermon
	rm -rf ./build/phpservermon/*
	git archive $(tag) | tar -xf - -C ./build/phpservermon/
	@echo 'Testing on syntax errors (thats all the automated testing your are going to get for now..) '
	find ./build/phpservermon -name "*.php" | xargs -I file php -l file
	find ./build/phpservermon -name "*.php" -exec sed -i "" "s/@package_version@/$(tag)/" {} \;
	@echo 'Building HTML documentation'
	cd ./build/phpservermon/docs; make BUILDDIR=. html; cd ../../../;
	@echo 'Cleaning up docs dir'
	rm -f ./build/phpservermon/docs/Makefile
	rm -f ./build/phpservermon/docs/make.bat
	rm -f ./build/phpservermon/docs/conf.py
	@echo 'Setting folder and file permissions'
	find ./build/phpservermon -type f | xargs chmod 0644
	find ./build/phpservermon -type d | xargs chmod 0755
	@echo 'Creating archives'
	cd ./build; zip -rq phpservermon-$(tag).zip ./phpservermon; cd ../;
	cd ./build; tar -pczf phpservermon-$(tag).tar.gz ./phpservermon; cd ../;
	rm -rf ./build/phpservermon
	@echo 'Building release finished '
