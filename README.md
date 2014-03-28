mapjs-server-silex
==================

After experimenting with the [Akka Persistence](http://doc.akka.io/docs/akka/snapshot/scala/persistence.html) module I wanted to see how far I could get with an Event Sourced / CQRS architecture in PHP.

This is still under heavy development... and web/index.php has been used as testing ground.

TODO
----

* rewrite some of the code that converts HTTP requests into commands
* implement a background script to process the commands
** in particular, implement a read model that stores data in SSE format
