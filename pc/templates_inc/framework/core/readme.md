# 核心模块
## C（Context部分）
### 新的外观实现方式
改变了原来使用__callStatic的魔术方法，通过更直接的设置获取来实现
删掉了原先addFacade,hasFacade,removeFacade的方法


## P
变量管理

与之前相比不兼容的点：
 - set可以覆盖之前的变量，不过会保有记录
 - get可以获取变量设置的记录
 - 去除了recordGet的方法