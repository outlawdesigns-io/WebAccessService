**Get All Clients**
----
  Returns json array of all LogMonitorRuns.

* **URL**

  /logMonitorRun/

* **Method:**

  `GET`

*  **URL Params**

  None

* **Data Params**

  None

* **Success Response:**

  * **Code:** 200 <br />
    **Content:**
    ```
    [
      {
	    "Id": "10",
	    "StartTime": "2019-09-29 06:00:01",
	    "EndTime": "2019-09-29 06:10:37",
	    "RunTime": "636",
	    "RecordsProcessed": "47",
	    "CombinedLogSize": "8.58",
	    "Hosts": "10"
	  },
      ....]
    ```

* **Error Response:**

  * **Code:** 200 <br />
    **Content:** `{ error : "Access Denied. No Token Present." }`

    OR

    * **Code:** 200 <br />
      **Content:** `{ error : "Access Denied. Invalid Token." }`

* **Sample Call:**

  ```javascript
    $.ajax({
      url: "/logMonitorRun/",
      dataType: "json",
      type : "GET",
      success : function(r) {
        console.log(r);
      }
    });
  ```
