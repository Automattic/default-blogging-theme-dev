
PKG="blogging-theme"

default: build

check-for-grunt:
	@if [ ! -f /usr/local/bin/grunt ]; then echo -e "\nGrunt CLI is not installed. Install it with sudo npm install -g grunt\n"; exit 1; fi

deps: check-for-grunt
	@npm install

clean:
	@rm -Rf build vars-build.*

build: clean check-for-grunt
	@grunt build
	
dev: clean check-for-grunt
	@grunt build && grunt watch
	
vars: clean check-for-grunt
	@node tools/sass-variables.js --prefix=x style.scss > vars-build.scss
	@grunt build && mv vars-build.css style.css && rm -f vars-build.scss

theme: clean
	@echo "* Initializing build"; mkdir -p build
	@echo "* Building assets"; make vars > /dev/null
	@echo "* Copying assets"; rsync -a . build/ --exclude-from=excludes.rsync; mv build/readme-theme.txt build/readme.txt
	@echo "* Integrity check"; node tools/buildtool.js --check --path build/
	@echo "* Zipping"; mv build ${PKG}; mkdir build; zip -mqr build/${PKG}.zip ${PKG}; cd build/; unzip -qq ${PKG}.zip

.PHONY: build