TARGETS = ../style.css

.PHONY: all
all: $(TARGETS)

../style.css: scss/style.scss
	sassc -t compressed -m $< $@

.PHONY: clean
clean:
	rm -f $(TARGETS)
