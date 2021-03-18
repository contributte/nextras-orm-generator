.PHONY: install qa cs csf phpstan tests coverage-clover coverage-html

install:
	composer update

qa:
	vendor/bin/linter src tests
	vendor/bin/codesniffer src tests

tests:
	vendor/bin/tester -s -p php --colors 1 -C tests/unit

coverage-clover:
	vendor/bin/tester -s -p phpdbg --colors 1 -C --coverage ./coverage.xml --coverage-src ./src tests/unit
