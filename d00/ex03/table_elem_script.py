import pandas as pd
import os

df = pd.read_csv("/mnt/c/Users/Victoria Nguyen/Desktop/data.csv", encoding = "ISO-8859-1", engine='python')
df.head()

data_len = len(df["Atomic_Number"])

atomic_mass = df["Atomic_Weight"].round(decimals=2)
elem = df["Symbol"]
atomic_num = df["Atomic_Number"]
classification = df["Type"]

table_file = open("table.html", "w")

for i in range (data_len):
	print("\t<td class=\"%s\">" % classification[i], file=table_file)
	print("\t\t<div>", file=table_file)
	print("\t\t\t<p class=\"atomic_mass\">%.2f</p>" % atomic_mass[i], file=table_file)
	print("\t\t\t<p class=\"element\">%s</h1>" % elem[i], file=table_file)		          
	print("\t\t\t<p class=\"atomic_num\">%d</p>" % atomic_num[i], file=table_file)
	print("\t\t</div>", file=table_file)	
	print("\t</td>", file=table_file)

table_file.close()