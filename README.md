# Storage
一個輕量級的陣列處理工具，可以透過它在利用陣列進行Join，及一些框架會有的基本工具包

它連到資料庫的底層是透過PDO，所以如果您換成不同資料庫，您可以不用改任何底層的程式，只需要改SQL就好

#### [特色]
1.你可以對二個陣列進行inner join, left join, right join, outer join, full join等

2.你可以對陣列進行排序，就像SQL的order by一樣

3.你可以輕鬆地將處理好的資料寫入檔案

4.你可以對陣列進行分頁

5.你可以同時寫入多台資料庫，且支持讀寫分離

6.你可以同時寫入多台memcache

7.你可以透過它進行快速套版，但快速套版的缺點在於你將喪失一些機器的效能換取你的開發速度，比較適合用在event page

8.你可以透過它進行圖片等比例裁切與縮放


#### [資料夾結構]
base - 底層程式資料夾

cache - 供你寫入檔案的資料夾

config - 存放設定資料夾

test - 測試程式資料夾，也可以當使用範例

index.php - 主程式


#### [如何使用]
你可以透過test資料夾中的測試範例去做參考


#### [About author]
Name    : Peter Cheng

Country : Taiwan

EMail 1 : teed7334@gmail.com

EMail 2 : teed7334@163.com
