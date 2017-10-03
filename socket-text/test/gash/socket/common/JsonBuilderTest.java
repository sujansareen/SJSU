package gash.socket.common;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import org.junit.AfterClass;
import org.junit.Assert;
import org.junit.BeforeClass;
import org.junit.Test;

import gash.socket.common.MessageBuilder.MessageType;
import gash.socket.data.Message;

public class JsonBuilderTest {
	final static String[] sList = { "one", "two", "three", "four" };

	@BeforeClass
	public static void setUpBeforeClass() throws Exception {
	}

	@AfterClass
	public static void tearDownAfterClass() throws Exception {
	}

	@Test
	public void testMapEncoding() throws Exception {
		HashMap<String, Object> data = new HashMap<String, Object>();
		data.put("name", "bubba");
		data.put("color", "green");
		data.put("food", "noodles");
		data.put("luckyNumber", 10);

		String out = JsonBuilder.encode(data);
		Assert.assertNotNull(out);
		System.out.println("JSON: " + out);
	}

	@Test
	public void testObjectEncoding() throws Exception {
		TestData data = new TestData();
		data.setName("bubba");
		data.setColor("green");
		data.setFood("noodles");
		data.setLuckyNumber(10);

		for (String i : sList)
			data.addItem(i);

		String out = JsonBuilder.encode(data);
		Assert.assertNotNull(out);
		System.out.println("JSON: " + out);

		List<TestData> rtn = JsonBuilder.decode(out, TestData.class);
		Assert.assertNotNull(rtn);
		Assert.assertNotEquals(0, rtn.size());
		rtn.forEach(item -> System.out.println(item));
	}

	@Test
	public void testMessageEncoding() throws Exception {
		Message data = new Message();
		data.setSource("test-src");
		data.setType(MessageType.join);
		data.setPayload("Test message");

		String out = JsonBuilder.encode(data);
		Assert.assertNotNull(out);
		System.out.println("JSON: " + out);

		List<TestData> rtn = JsonBuilder.decode(out, TestData.class);
		Assert.assertNotNull(rtn);
		Assert.assertNotEquals(0, rtn.size());
		rtn.forEach(item -> System.out.println(item));

	}

	public static class TestData {
		private String name;
		private String color;
		private String food;
		private int luckyNumber;
		private ArrayList<String> items;

		public String toString() {
			return ("name = " + name + ", color = " + color + ", food = " + food);
		}

		public void addItem(String item) {
			if (items == null)
				items = new ArrayList<String>();

			if (item != null)
				items.add(item);
		}

		public String getName() {
			return name;
		}

		public void setName(String name) {
			this.name = name;
		}

		public String getColor() {
			return color;
		}

		public void setColor(String color) {
			this.color = color;
		}

		public String getFood() {
			return food;
		}

		public void setFood(String food) {
			this.food = food;
		}

		public ArrayList<String> getItems() {
			return items;
		}

		public void setItems(ArrayList<String> items) {
			this.items = items;
		}

		public int getLuckyNumber() {
			return luckyNumber;
		}

		public void setLuckyNumber(int luckyNumber) {
			this.luckyNumber = luckyNumber;
		}

	}
}
