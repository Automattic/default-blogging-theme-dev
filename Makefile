
PKG="blogging-theme"

default: build
	
deps:
	@npm install
	
clean:
	@rm -Rf build vars-build.*

build: clean
	@grunt build
	
dev: clean
	@grunt build && grunt watch
	
vars: clean
	@node tools/sass-variables.js --prefix=x style.scss > vars-build.scss
	@grunt build && mv vars-build.css style.css && rm -f vars-build.scss

theme: clean
	@echo "* Initializing build"; mkdir -p build
	@echo "* Building assets"; make vars > /dev/null
	@echo "* Copying assets"; rsync -a . build/ --exclude-from=excludes.rsync; mv build/readme-theme.txt build/readme.txt
	@echo "* Integrity check"; node tools/buildtool.js --check --path build/
	@echo "* Zipping"; mv build ${PKG}; mkdir build; zip -mqr build/${PKG}.zip ${PKG}; cd build/; unzip -qq ${PKG}.zip

.PHONY: build