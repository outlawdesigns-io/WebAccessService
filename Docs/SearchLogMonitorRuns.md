**Search LogMonitorRuns**
----
  Returns json array of LogMonitorRuns matching given search parameters.

* **URL**

  /logMonitorRun/search/:key/:value

* **Method:**

  `GET`

*  **URL Params**

   **Required:**

   `key=[string] -- The field to search on`
   `value=[integer,boolean,string,date] -- The value to search by`

* **Data Params**

  None

* **Success Response:**

  * **Code:** 200 <br />
    **Content:**
    ```
    [
      {
        "Id": "3458",
        "StartTime": "2020-12-01 00:00:01",
        "EndTime": "2020-12-01 00:02:03",
        "RunTime": "123",
        "RecordsProcessed": "80",
        "CombinedLogSize": "16.28",
        "Hosts": "13"
      },
      {
        "Id": "3459",
        "StartTime": "2020-12-01 03:00:02",
        "EndTime": "2020-12-01 03:03:04",
        "RunTime": "183",
        "RecordsProcessed": "31",
        "CombinedLogSize": "16.29",
        "Hosts": "13"
      },
    ....]    
    ```

* **Error Response:**

  * **Code:** 200 <br />
    **Content:** `{ error : "Unknown column 'garbage' in 'where clause'" }`

  OR

  * **Code:** 200 <br />
    **Content:** `{ error : "Access Denied. No Token Present." }`

    OR

    * **Code:** 200 <br />
      **Content:** `{ error : "Access Denied. Invalid Token." }`

* **Sample Call:**

  ```javascript
    $.ajax({
      url: "/logMonitorRun/search/StartTime/2020-12",
      dataType: "json",
      type : "GET",
      success : function(r) {
        console.log(r);
      }
    });
  ```
