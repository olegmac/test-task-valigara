# Test task - MWS Shipment implementation.

This task took me about 5.5 hrs including this text. Although, it's first time I used MWS API.

### Common

I didn't write any tests due to time limit. I also have no MWS account, so tests using real API calls would fail anyway. API interface is testable, Adapter is testable too.

Code style differs a bit, because I'm used to writing camelCase instead of under_line. I also don't know about codestyle in project, i.g. if o-prefix for object variables and I-prefix for interfaces is necessary.

### Step 1

I don't know if structure of namespaces and classes should have been preserved. If yes, it could easily be done. 

I also fixed some typos. In real case I wouldn't, just let the adapter class do transformation.

### Step 2

I moved get_country_code and get_county_code3 into properties. In real case I'd also preserve them as a possible fallback with some monitoring if they're ever called.

Actually, for me normal structure looks like Order object with properties like Buyer, Address, ItemCollection etc. Didn't do that.

### Step 3

I used composer to simplify the autoload. There's no problem to write spl_autoload_register though.

### Steps 4-5

In my practice I usually separate Request models, Response models, Settings and Validators. This time I had to simplify it a bit due to time limits.
