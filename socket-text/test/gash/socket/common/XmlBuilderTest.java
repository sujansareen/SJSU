package gash.socket.common;

import org.junit.AfterClass;
import org.junit.Assert;
import org.junit.BeforeClass;
import org.junit.Test;

import gash.socket.common.MessageBuilder.MessageType;
import gash.socket.data.Message;
import gash.socket.server.MessageListener;

public class XmlBuilderTest {

	@BeforeClass
	public static void setUpBeforeClass() throws Exception {
	}

	@AfterClass
	public static void tearDownAfterClass() throws Exception {
	}

	@Test
	public void testMessageEncoding() throws Exception {
		Message data = new Message();
		data.setSource("test-src");
		data.setType(MessageType.join);
		data.setPayload("This is a test");

		// to xml
		String out = XmlBuilder.encode(data);
		Assert.assertNotNull(out);
		System.out.println("XML: " + out);

		MessageListener listen = new MessageListener() {

			@Override
			public void onMessage(Message msg) {
				System.out.println("Object: " + msg);
			}

		};

		// to object
		XmlBuilder xb = new XmlBuilder();
		xb.addListener(listen);
		xb.process(out.getBytes(), out.length());
	}

}
