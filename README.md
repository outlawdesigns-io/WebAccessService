# Web Access REST API

## Preamble

The Web Access service provides programmatic access to [AccessLogParser](https://github.com/outlawdesigns-io/AccessLogParser) models and services by remote clients. This service can be used to build reports or client applications in any language that supports making http calls.

## Meta

### Security

This API is accessible only by registered users of outlawdesigns.io who present a valid Oauth2 access token.

#### Sample Call
```
curl --location --request POST 'https://auth.outlawdesigns.io/oauth2/token' \
--form 'grant_type="client_credentials"' \
--form 'client_id="$CLIENT_ID"' \
--form 'client_secret="CLIENT_SECRET"' \
--form 'audience="https://webaccess.outlawdesigns.io"' \
--form 'scope="openid, profile, email, roles"'
```

### Reporting performance or availability problems

Report performance/availability at our [support site](mailto:j.watson@outlawdesigns.io).

### Reporting bugs, requesting features

Please report bugs with the API or the documentation on our [issue tracker](https://github.com/outlawdesigns-io/WebAccessService/issues).

## Endpoints

### request/
Returns either a single JSON encoded `Request` object or an array of JSON encoded `Request` objects.
* [GetRequest](./Docs/GetRequest.md)
* [GetAllRequests](./Docs/GetAllRequests.md)
* [GroupRequests](./Docs/GroupRequests.md)
* [RecentRequests](./Docs/RecentRequests.md)
* [SearchRequests](./Docs/SearchRequests.md)



### host/
Returns either a single JSON encoded `Host` object or an array of JSON encoded `Host` objects.

* [GetHost](./Docs/GetHost.md)
* [GetAllHosts](./Docs/GetAllHosts.md)
* [CreateHost](./Docs/CreateHost.md)
* [UpdateHost](./Docs/UpdateHost.md)
* [GroupHosts](./Docs/GroupHosts.md)
* [RecentHosts](./Docs/RecentRequests.md)
* [SearchHosts](./Docs/SearchHosts.md)

### client/
Returns either a single JSON encoded `Client` object or an array of JSON encoded `Client` objects.

* [GetClient](./Docs/GetClient.md)
* [GetAllClients](./Docs/GetAllClients.md)
* [GroupClients](./Docs/GroupClients.md)
* [RecentClients](./Docs/RecentClients.md)
* [SearchClients](./Docs/SearchClients.md)

### logMonitorRun/

Returns either a single JSON encoded `LogMonitorRun` object or an array of JSON encoded `LogMonitorRun` objects.
* [GetLogMonitorRun](./Docs/GetLogMonitorRun.md)
* [GetAllLogMonitorRuns](./Docs/GetAllLogMonitorRuns.md)
* [GroupLogMonitorRuns](./Docs/GroupLogMonitorRuns.md)
* [RecentLogMonitorRuns](./Docs/RecentLogMonitorRuns.md)
* [SearchLogMonitorRuns](./Docs/SearchLogMonitorRuns.md)
