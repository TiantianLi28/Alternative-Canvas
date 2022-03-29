import pandas as pd
assignment=pd.read_csv('assignment.csv',header=None)
assignment.columns=['number','semester','year','name','time','text','point','aid']
record=pd.read_csv('does.csv')
record.columns=['id','number','semester','year','name','text','point','got']
dic={}
list=[]
for rows in range(len(assignment)):
    dic[assignment.iloc[rows,0]+assignment.iloc[rows,1]+str(assignment.iloc[rows,2])+assignment.iloc[rows,3]]=assignment.iloc[rows,7]
print(dic)
'''for rows in range(len(record)):
    list.append(dic[record.iloc[rows,1]+record.iloc[rows,2]+str(record.iloc[rows,3])+record.iloc[rows,4]])
record['aid']=list
record.to_csv('do.csv',index=False, header=False)'''

