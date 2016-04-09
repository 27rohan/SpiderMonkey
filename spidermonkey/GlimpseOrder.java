import java.io.*;
import java.util.*;

class TagToken
{
	public String tag;
	public int count;
	
	public TagToken(String tag)
	{
		this.tag = tag;
		this.count = 0;
	}
}
// define a function to check if a string is valid or not
// Basically iterates through every string in the input file and if the input string is a valid keyword and hasn't yet been added, add it with count==1
// if the keyword is already present, increase its count
// sorts the arraylist according to decreasing order of count


class GlimpseOrder
{
	static String invalids[] = new String[]{"a", "an", "the", "of", "aboard", "about", "above", "across", "after", "along", "amid", "among", "around", "as", "at", "before", "behind", "below", "beneath", "beside", "besides", "between", "beyond", "but", "by", "despite", "down", "during", "except", "for", "from", "in", "inside", "into", "near", "of", "off", "on", "onto", "over", "per", "since", "than", "through", "to", "under", "underneath", "unlike", "until", "up", "upon", "with", "and", "but", "or", "nor", "for", "yet", "so", "unless", "though", "that", "than", "rather", "lest", "although", "|"};
	public static void main(String args[])
	{
		
		ArrayList<TagToken> taglist = new ArrayList<TagToken>();
		ArrayList<String> stringlist = new ArrayList<String>();
		
		String tagsplit[] = args;
		TagToken temptoken;
		
		for(int i=0; i<tagsplit.length; i++)
		{
			if(!stringlist.contains(tagsplit[i]) && !checkInvalid(tagsplit[i]))
			{
				stringlist.add(tagsplit[i]);
				taglist.add(new TagToken(tagsplit[i]));
			}
		}
		
		TagToken ta[] = new TagToken[taglist.size()];
		taglist.toArray(ta);
		
		for(int i=0; i<tagsplit.length; i++)
		{
			for(int j=0; j<ta.length; j++)
			{
				if(tagsplit[i].equals(ta[j].tag))
				{
					ta[j].count++;
				}
			}
		}
		
		for(int i=0; i<ta.length; i++)
			for(int j=i+1; j<ta.length; j++)
			{
				if(ta[i].count<ta[j].count)
				{
					temptoken = ta[i];
					ta[i] = ta[j];
					ta[j] = temptoken;
				}
			}
			
		for(int i=0; i<5; i++)
		{
			System.out.println(ta[i].tag);
		}
	}
	
	public static boolean checkInvalid(String x)
	{
		if(!x.matches("[a-zA-Z1-9,'&!$()]*"))
		{
			return true;
		}
		for(String invalid: invalids)
		{
				if(invalid.equalsIgnoreCase(x))
					return true;
		}
		return false;
	} 
}