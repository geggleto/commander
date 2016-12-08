# Commander

Micro-Service Command/Event Framework

- HTTP Requests are turned into Commands
- You write Handlers not Controllers
- You write Events to return results.

### Scenario

1. HTTP Request get's processed by Commander
2. Commander makes a command and sends it to the Command Bus
3. The handler for that command (Which you write) gets executed.
4. The Handler must fire off a framework Event (`Completed`, `Error`) or another Event that leads to a `Completed` or 
`Error `Event being emitted.
5. Commander Returns the Event that was fired.
6. You render it.


## Contributors

- Glenn Eggleton <geggleto@gmail.com>

