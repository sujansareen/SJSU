/**
 * Copyright 2016 Gash.
 *
 * This file and intellectual content is protected under the Apache License, version 2.0
 * (the "License"); you may not use this file except in compliance with the
 * License.  You may obtain a copy of the License at:
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.  See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */
package gash.router.app;

import gash.router.client.CommConnection;
import gash.router.client.CommListener;
import gash.router.client.MessageClient;
import routing.Pipe.Route;
import java.util.*;
import java.io.*;

public class DemoApp implements CommListener {
	private MessageClient mc;

	public DemoApp(MessageClient mc) {
		init(mc);
	}
    public String shortMsg = "Hello Word ";
    public String medMsg =  new String(new char[300]).replace("\0", shortMsg);
    public String lgMsg =  new String(new char[3000]).replace("\0", shortMsg);
	private void init(MessageClient mc) {
		this.mc = mc;
		this.mc.addListener(this);
	}
    /**
     * Open and read a file, and return the lines in the file as a list
     * of Strings.
     * (Demonstrates Java FileReader, BufferedReader, and Java5.)
     */
    private List<String> readFile(String filename)
    {
        List<String> records = new ArrayList<String>();
        try
        {
            BufferedReader reader = new BufferedReader(new FileReader(filename));
            String line;
            while ((line = reader.readLine()) != null)
            {
                records.add(line);
            }
            reader.close();
            return records;
        }
        catch (Exception e)
        {
            System.err.format("Exception occurred trying to read '%s'.", filename);
            e.printStackTrace();
            return null;
        }
    }

    // send a message
    private void postMessage(int N) {
        final int maxN = 10;
        long[] dt = new long[N];
        long st = System.nanoTime(), ft = 0;

        for (int n = 0; n < N; n++) {
            mc.postMessage(lgMsg + n);
            ft = System.nanoTime();
            dt[n] = ft - st;
            st = ft;
        }

        System.out.println("Round-trip post times (msec)");
        for (int n = 0; n < N; n++)
            System.out.printf("%d :  %.3f%n ",n, dt[n]/1e6);
        System.out.println("");
    }
    // test round-trip overhead (note overhead for initial connection)
    private void ping(int N) {
		final int maxN = 10;
		long[] dt = new long[N];
		long st = System.nanoTime(), ft = 0;
		for (int n = 0; n < N; n++) {
			mc.ping();
			ft = System.nanoTime();
			dt[n] = ft - st;
			st = ft;
		}

		System.out.println("Round-trip ping times (msec)");
		for (int n = 0; n < N; n++)
            System.out.printf("%d :  %.3f%n ",n, dt[n]/1e6);
		System.out.println("");
	}

	@Override
	public String getListenerID() {
		return "demo";
	}

	@Override
	public void onMessage(Route msg) {
		System.out.println("---> " + msg);
	}
    public static DemoApp startConnection(String host, int port) {
        MessageClient mc = new MessageClient(host, port);

        return new DemoApp(mc);
    }
	/**
	 * sample application (client) use of our messaging service
	 * 
	 * @param args
	 */
	public static void main(String[] args) {
        String host = "10.21.1.10";
		int port = 4567;
        int n = 1;

		try {
            System.out.printf("\n** 1 **\n");
            System.out.print(CommConnection.getInstance());
            System.out.printf("\n** 2 **");
            DemoApp da = startConnection(host,port);
			// do stuff w/ the connection
            //da.ping(n);
            //da.postMessage(n);
            System.out.printf("\n** 3 **");
            System.out.print(CommConnection.getInstance());
			System.out.printf("\n** exiting in %d seconds. **",n);
			System.out.flush();
			Thread.sleep(n * 1000);
		} catch (Exception e) {
            System.out.printf("\n** Catch. **",n);
			e.printStackTrace();
		} finally {
			CommConnection.getInstance().release();
		}
	}
}
